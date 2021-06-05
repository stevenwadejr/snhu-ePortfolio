# Enhancement One: Databases

**Note:** This application requires NodeJS and MongoDB installed locally to run.

This application structure was generated using [MEVN](https://mevn.madlabs.xyz/guide/installation.html). While not necessarily required to run the application, it makes it simpler.

## Installation

### Set up the server

Install dependencies: `cd server && npm install`

Set up the environment: `cp .env.example .env`. Then open the `.env` file and update the MongoDB variables for your local configuration.

### Set up the client

Install dependencies: `cd client && npm install`

Set up the environment: `cp .env.example .env`. Then open the `.env` file and update the API url to that of the server's (defaults to: `http://localhost:9000`).

## Running the application

### Via NodeJS

Open two terminal windows and run each command in a single window:

`cd server && npm run serve` and `cd client && npm run serve`

### Via MEVN

Open two terminal windows and run each command in a single window from this directory: `mevn serve`
