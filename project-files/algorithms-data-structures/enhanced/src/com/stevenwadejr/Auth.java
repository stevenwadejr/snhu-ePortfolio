package com.stevenwadejr;

import com.stevenwadejr.exceptions.MaxLoginAttemptsReached;

import java.security.MessageDigest;
import java.util.Optional;
import java.util.function.Function;

/**
 * Handles authentication for a user.
 *
 * @author Steven Wade
 */
public class Auth {

	/**
	 * The maximum number of login attempts a user can perform
	 */
	private static final int MAX_LOGIN_ATTEMPTS = 3;

	/**
	 * The instance of the currently logged in user
	 */
	private User user = null;

	/**
	 * Tracks the current number of login attempts the user has made
	 */
	private int loginAttempts = 0;

	/**
	 * The authentication repository used to look up user information
	 */
	private final AuthRepository repository;

	/**
	 * A callback listener executed when a user logs in
	 */
	public Function<User, Void> onLogin;

	/**
	 * A callback listener executed when a user logs out
	 */
	public Function<Boolean, Void> onLogout;

	/**
	 * Takes a repository instance that handles actually
	 * fetching the user record from a data store.
	 *
	 * @param repository A concrete instance of a repository used to find and manage users
	 */
	public Auth(AuthRepository repository) {
		this.repository = repository;
	}

	/**
	 * Looks up a user record in the data store. If one is found, it
	 * will set an instance of a User on this class. Three failed
	 * login attempts will trigger an error.
	 *
	 * @param username the username of a user to lookup.
	 * @param password the raw text password for a user to hash and lookup.
	 * @throws MaxLoginAttemptsReached throws an exception when the max login attempts are made.
	 */
	public void login(String username, String password) throws Exception {
		Optional<User> record = repository.findUserRecord(username, hash(password));

		// If the repository found a matching user
		if (record.isPresent()) {
			user = record.get();

			// Call the event listener if it has been set
			if (onLogin != null) {
				onLogin.apply(user);
			}

			return;
		}

		// Increment the login attempts prior to checking. That way we can see earlier
		// if the user has tried to many times and failed.
		if (++loginAttempts >= MAX_LOGIN_ATTEMPTS) {
			throw new MaxLoginAttemptsReached();
		}
	}

	/**
	 * Logs the user out by resetting the login attempts
	 * and unsetting the user record.
	 */
	public void logout() {
		loginAttempts = 0;
		user = null;

		if (onLogout != null) {
			onLogout.apply(true);
		}
	}

	/**
	 * @return whether a user is logged in or not.
	 */
	public boolean isLoggedIn() {
		return user != null;
	}

	/**
	 * Getter for the current logged in user. Can be
	 * null if no one is currently logged in.
	 *
	 * @return the instance of the logged in User.
	 */
	public User getUser() {
		return user;
	}

	/**
	 * Hashes a raw text string.
	 *
	 * @param password the raw text password to hash.
	 * @return the md5 hash of the password.
	 */
	public String hash(String password) {
		try {
			MessageDigest md = MessageDigest.getInstance("MD5");
			md.update(password.getBytes());
			byte[] digest = md.digest();
			StringBuffer sb = new StringBuffer();
			for (byte b : digest) {
				sb.append(String.format("%02x", b & 0xff));
			}

			return sb.toString();
		} catch (Exception e) {
			System.out.println("Error hashing the user's password: " + e.getMessage());

			// Return an empty string so we can fail silently but still log the error.
			return "";
		}
	}
}
