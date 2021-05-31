package com.stevenwadejr;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.util.HashMap;
import java.util.Optional;
import java.util.Scanner;

/**
 * Implementation for the AuthRepository that looks up
 * user records in a credentials text file.
 *
 * @author Steven Wade
 */
public class CredentialsFileRepository implements AuthRepository {

	/**
	 * File name where the users and their credentials are stored
	 */
	private static final String CREDENTIALS_FILE = "credentials.txt";

	/**
	 * The repository's internal database of users, keyed by users' unique email address
	 */
	private final HashMap<String, User> users = new HashMap<>();

	public CredentialsFileRepository() {
		// Load the credentials file into memory
		loadCredentialsFile();
	}

	/**
	 * Find the record of a user matching a given username
	 * and password (hash) in a credentials text file.
	 *
	 * @param username     the username of the user to look up.
	 * @param passwordHash hashed password of the user record.
	 * @return a raw user record array consisting of username, passwordHash, and role.
	 */
	public Optional<User> findUserRecord(String username, String passwordHash) {
		return users.containsKey(username) && users.get(username).getPassword().equals(passwordHash)
				? Optional.of(users.get(username))
				: Optional.empty();
	}

	private void loadCredentialsFile() {
		// Use a try with resources here to open a stream to a file.
		// This will auto-close the file when the block is finished executing.
		// see: https://docs.oracle.com/javase/tutorial/essential/exceptions/tryResourceClose.html
		try (FileInputStream stream = new FileInputStream("./resources/" + CREDENTIALS_FILE)) {
			Scanner scanner = new Scanner(stream);

			// Each line in the file represents a user record. Load each one into the repository's
			// internal database (hash map).
			while (scanner.hasNextLine()) {
				// User record fields are separated by a tab character. Split on tabs
				// and populate a row with individual fields.
				String[] row = scanner.nextLine().split("\\t");

				// Create a new user with the username, hashed password, and role
				User user = new User(row[0], row[1], row[3]);

				// Usernames are unique, so use that as the key to store the user in the
				// repository's hash map of users.
				users.put(user.getUsername(), user);
			}
		} catch (FileNotFoundException e) {
			System.out.println("Credentials file not found");
		} catch (Exception e) {
			System.out.println("Error loading user credentials from file: " + e.getMessage());
		}
	}
}
