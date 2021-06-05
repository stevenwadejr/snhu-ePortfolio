import mongodb from "mongodb";
import cors from "cors";
import express, { json } from "express";
import dotenv from "dotenv";
import routes from "./routes/api.js";
import path from "path";

// parse env variables
dotenv.config();

// Configuring port
const port = process.env.PORT || 9000;
const MongoClient = mongodb.MongoClient;
const mongoUrl = `mongodb://${process.env.DB_USER}:${process.env.DB_PASS}@${process.env.DB_HOST}?authSource=admin`;
const app = express();

(async function () {
    let client;
    let db;

    try {
        // Use connect method to connect to the Server
        client = await MongoClient.connect(mongoUrl, {
            useUnifiedTopology: true,
            useNewUrlParser: true,
        });
        db = client.db(process.env.DB_NAME);
        const surveyData = await db.collection("survey_data").countDocuments();
    } catch (err) {
        console.log("Error connecting to MongoDB");
        console.log(err.stack);
        process.exit(1);
    }

    // Configure middlewares
    app.use(cors());
    app.use(json());
    app.use(async (req, res, next) => {
        req.context = { db };
        next();
    });

    // Defining route middleware
    app.use("/api", routes);

    app.use(express.static(process.cwd() + "/public/"));
    app.get("/", (req, res) => {
        res.sendFile(path.join(process.cwd(), "public", "index.html"));
    });

    app.listen(port);
    console.log(`Listening On http://localhost:${port}`);
})();

// app.set('view engine', 'html');

export default app;
