package com.stevenwadejr;

import javax.swing.*;

/**
 * Main entry point of the application and acts as a container, storing singletons
 * used throughout the application.
 *
 * @author Steven Wade
 */
public class App {

	/**
	 * Authentication class
	 *
	 * @singleton
	 */
	private static Auth auth;

	/**
	 * Roles Repository
	 *
	 * @singleton
	 */
	private static RolesFileRepository rolesRepository;

	/**
	 * The application's parent frame
	 */
	private static JFrame frame;

	/**
	 * Login view
	 */
	private static JPanel loginView;

	/**
	 * Main view after login
	 */
	private static JPanel mainView;

	/**
	 * Static method to gain access to the Auth singleton
	 *
	 * @return Auth
	 */
	public static Auth auth() {
		return auth;
	}

	public static void main(String[] args) {
		// Instantiate the Auth singleton and inject the credentials
		// repository as a dependency
		auth = new Auth(new CredentialsFileRepository());

		// Instantiate the roles repository
		rolesRepository = new RolesFileRepository();

		// Create the parent frame of the GUI
		frame = new JFrame("Zoo Admin");
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.setSize(300, 450);
		frame.setVisible(true);

		// Add a callback listener for when a user is logged out. When a user
		// is logged out, we want to show the logged in screen again.
		auth.onLogout = (Boolean didLogout) -> {
			showLoginView();
			return null;
		};

		// Add a callback listener for when a user is logged in. When a user
		// successfully logs in, we want to show the main view and remove the
		// login view.
		auth.onLogin = (User user) -> {
			showMainView();
			return null;
		};

		// Show the login view on start up
		showLoginView();
	}

	/**
	 * Create the login view and remove the main view if it exists. Add the
	 * login view to the frame and redraw the frame.
	 */
	private static void showLoginView() {
		loginView = new LoginView(frame);

		if (mainView != null) {
			frame.remove(mainView);
		}

		frame.setContentPane(loginView);
		frame.validate();
		frame.repaint();
		mainView = null;
	}

	/**
	 * Create the main view and remove the login view if it exists. Add the
	 * main view to the frame and redraw the frame.
	 */
	private static void showMainView() {
		mainView = new MainView(frame, rolesRepository);

		if (loginView != null) {
			frame.remove(loginView);
		}

		frame.setContentPane(mainView);
		frame.validate();
		frame.repaint();
		loginView = null;
	}
}
