package com.stevenwadejr;

/**
 * DTO representing a user. Contains their username,
 * a hashed password, and their role.
 *
 * @author Steven Wade
 */
public class User {
	private final String username;

	private final String password;

	private final String role;

	public User(String username, String password, String role) {
		this.username = username;
		this.password = password;
		this.role = role;
	}

	public String getUsername() {
		return username;
	}

	public String getPassword() {
		return password;
	}

	public String getRole() {
		return role;
	}
}
