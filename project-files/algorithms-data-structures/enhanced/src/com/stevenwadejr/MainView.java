package com.stevenwadejr;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

/**
 * View class for the main view of the application. The class itself
 * is a panel that will declare and position UI elements within its view.
 *
 * @author Steven Wade
 */
public class MainView extends JPanel {
	public MainView(JFrame frame, RoleRepository roleRepository) {
		// This view uses a border layout to create top and center UI regions.
		setLayout(new BorderLayout(10, 10));

		// Create a new panel view that uses the flow layout that centers its
		// child elements. Add the top panel view to the top section (north)
		// of the main view.
		JPanel topPanel = new JPanel();
		topPanel.setLayout(new FlowLayout(FlowLayout.CENTER));
		add(topPanel, BorderLayout.NORTH);

		// Set the size of the top panel and give it a border on the bottom
		topPanel.setPreferredSize(new Dimension(frame.getWidth(), 40));
		topPanel.setBorder(BorderFactory.createMatteBorder(0, 0, 2, 0, Color.BLACK));

		// Create a welcome label that displays the username of the logged in user.
		JLabel welcomeLabel = new JLabel();
		welcomeLabel.setText("Welcome " + App.auth().getUser().getUsername() + "!");

		// Add the welcome label to the top panel view
		topPanel.add(welcomeLabel);

		// Create a button to allow the user to log out of the application.
		JButton logoutBtn = new JButton("Logout");

		// Create an event listener that will log the user out when the button is pressed.
		logoutBtn.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				App.auth().logout();
			}
		});

		// Add the log out button to the top panel view
		topPanel.add(logoutBtn);


		// Create a new panel view that will function as the bottom portion of this view
		// but will be positioned within the center of the border layout.
		JPanel bottomPanel = new JPanel();
		add(bottomPanel, BorderLayout.CENTER);

		// Find information pertaining to the role of the currently logged in user
		String roleInfo = roleRepository.findRoleInfo(App.auth().getUser().getRole());

		// Create a text area to display the role info. Set it's styling and don't let it
		// be editable by the user.
		JTextArea roleTextArea = new JTextArea(roleInfo);
		roleTextArea.setEditable(false);
		roleTextArea.setLineWrap(true);
		roleTextArea.setWrapStyleWord(true);
		roleTextArea.setOpaque(false);
		roleTextArea.setBackground(new Color(0, 0, 0, 0));
		roleTextArea.setColumns(20);
		roleTextArea.setRows(10);

		// Add the role text area to the bottom panel view
		bottomPanel.add(roleTextArea);
	}
}
