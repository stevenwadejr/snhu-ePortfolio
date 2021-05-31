package com.stevenwadejr;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.HashMap;

/**
 * File-based implementation of the role repository. Roles are loaded into
 * memory and then looked up on demand.
 *
 * @author Steven Wade
 */
public class RolesFileRepository implements RoleRepository {

	/**
	 * Internal database of role information keyed by the role
	 */
	private final HashMap<String, String> roles = new HashMap<>();

	/**
	 * Load all role TXT files upon instantiation
	 */
	public RolesFileRepository() {
		loadRoleFiles();
	}

	/**
	 * Finds information about a given role.
	 *
	 * @param role String The name of the role to lookup
	 * @return String Information about the given role
	 */
	@Override
	public String findRoleInfo(String role) {
		return roles.getOrDefault(role, "");
	}

	/**
	 * Load all role TXT files into memory
	 */
	private void loadRoleFiles() {

		try {
			// Loop over every role file
			Files.walk(Paths.get("./resources/roles"))
					.filter(Files::isRegularFile)
					.forEach(path -> {
						try {
							// Grab the role name from the text file (ex: admin.txt)
							String roleName = path.getFileName().toString().replaceFirst("[.][^.]+$", "");

							// Load the role data from the text file
							String data = new String(Files.readAllBytes(Paths.get(String.valueOf(path))));

							// Add the role info to the roles database (hash map) keyed by the role name which is unique.
							roles.put(roleName, data);
						} catch (IOException e) {
							e.printStackTrace();
						}
					});
		} catch (Exception e) {
			System.out.println("Exception: " + e.getMessage());
		}
	}
}
