package com.stevenwadejr.exceptions;

/**
 * Exception to be thrown when a user has too many failed login attempts
 *
 * @author Steven Wade
 */
public class MaxLoginAttemptsReached extends Exception {
	public MaxLoginAttemptsReached() {
		super("Too many failed login attempts");
	}
}
