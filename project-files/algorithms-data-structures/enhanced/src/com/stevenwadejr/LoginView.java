package com.stevenwadejr;

import com.stevenwadejr.exceptions.MaxLoginAttemptsReached;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

/**
 * View class for the login view of the application. The class itself
 * is a panel that will declare and position UI elements within its view.
 *
 * @author Steven Wade
 */
public class LoginView extends JPanel {

	// Defines positional spacing values used for elements in this view
	final int MARGIN = 30;
	final int PADDING = 20;

	// UI fields within this view
	JTextField usernameField;
	JPasswordField passwordField;
	JButton loginBtn;
	JLabel errorLabel;

	public LoginView(JFrame frame) {
		// Clear any existing layout as this panel won't use one.
		setLayout(null);

		// Create a label for the username field
		JLabel usernameLabel = new JLabel("Username");
		usernameLabel.setBounds(MARGIN, 120, 70, 40);

		// Add the username label to the view
		add(usernameLabel);

		// Create a text input field for the username. Position it relative
		// to the username label.
		int usernameFieldX = MARGIN + usernameLabel.getWidth() + PADDING;
		usernameField = new JTextField();
		usernameField.setToolTipText("Username");
		usernameField.setBounds(
				usernameFieldX,
				usernameLabel.getY(),
				frame.getWidth() - usernameFieldX - MARGIN,
				40
		);

		// Add the username field to the view
		add(usernameField);

		// Create a label for the password field and position it relative
		// to the username label.
		JLabel passwordLabel = new JLabel("Password");
		passwordLabel.setBounds(
				MARGIN,
				usernameLabel.getY() + usernameLabel.getHeight() + PADDING,
				70,
				40
		);

		// Add the label to the view
		add(passwordLabel);

		// Create a password input field and position it relative to the username
		// field and the password label.
		passwordField = new JPasswordField();
		passwordField.setToolTipText("password");
		passwordField.setBounds(
				usernameFieldX,
				passwordLabel.getY(),
				frame.getWidth() - usernameFieldX - MARGIN,
				40
		);

		// Add the password field to the view
		add(passwordField);

		// Allow "enter" presses to fire events on buttons.
		// @see https://groups.google.com/g/comp.lang.java.programmer/c/FqMCBkpGjDg/m/saS-tvg9QeYJ
		UIManager.put("Button.focusInputMap", new UIDefaults.LazyInputMap(new
				Object[]{
				"ENTER", "pressed",
				"released ENTER", "released"
		}));

		// Create a button that will trigger a login attempt. Position it relative to
		// the password field.
		loginBtn = new JButton("Login");
		loginBtn.setBounds(
				frame.getWidth() - MARGIN - 80,
				passwordLabel.getY() + passwordLabel.getHeight() + PADDING,
				80,
				40
		);

		// Add an event listener for when the button is pressed. When pressed, call the
		// `doLogin` function on this view class.
		loginBtn.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				doLogin();
			}
		});

		// Add the login button to the view
		add(loginBtn);

		// Create a label that will show error messages to the user. Position it
		// relative to the login button.
		errorLabel = new JLabel();
		errorLabel.setForeground(Color.RED);
		errorLabel.setHorizontalAlignment(SwingConstants.CENTER);
		errorLabel.setBounds(
				MARGIN,
				loginBtn.getY() + loginBtn.getHeight() + PADDING,
				frame.getWidth() - (MARGIN * 2),
				40
		);

		// Add the error label to the view
		add(errorLabel);
	}

	/**
	 * Method used to attempt a login
	 */
	private void doLogin() {
		try {
			// Call the Auth singleton on the App container and give it the
			// username and password values from the respective fields.
			App.auth().login(usernameField.getText(), String.valueOf(passwordField.getPassword()));

			// If the user successfully logged in, clear the error label's text, otherwise
			// let the user the user was not found.
			if (App.auth().isLoggedIn()) {
				errorLabel.setText("");
			} else {
				errorLabel.setText("User not found");
			}
		} catch (MaxLoginAttemptsReached e) {
			// When the maximum number of login attempts has been reached, disable the
			// login form and let the user know they've tried too many times.
			loginBtn.setEnabled(false);
			errorLabel.setText("Too many login attempts");
		} catch (Exception e) {
			// Log any other error we might experience here.
			System.out.println("Error logging in: " + e.getMessage());
		}
	}
}
