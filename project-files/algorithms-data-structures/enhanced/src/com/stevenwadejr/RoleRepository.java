package com.stevenwadejr;

/**
 * Interface for finding information about a given role
 *
 * @author Steven Wade
 */
public interface RoleRepository {

	/**
	 * Finds information about a given role.
	 *
	 * @param role String The name of the role to lookup
	 * @return String Information about the given role
	 */
	String findRoleInfo(String role);
}
