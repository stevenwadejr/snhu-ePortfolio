package com.stevenwadejr;

import java.util.Optional;

/**
 * Interface for finding a user record for an
 * implemented data store.
 *
 * @author Steven Wade
 */
public interface AuthRepository {

	Optional<User> findUserRecord(String username, String passwordHash);
}
