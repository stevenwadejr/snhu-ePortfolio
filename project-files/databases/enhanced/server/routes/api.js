/**
 * This file declares all routes for the API
 *
 * @author Steven Wade <stevenwadejr@gmail.com>
 */

import { Router } from "express";
import * as reports from "../models/reports.js";

const router = Router();

// Paginates all results
router.get("/", async (req, res) => {
    // Find query information used in pagination
    const pageSize = parseInt(req.query.limit) || 100;
    const page = parseInt(req.query.page) || 1;

    // Cache the pointer to the database collection
    const collection = await req.context.db.collection("survey_data");

    // Calculate the total number of documents in this collection
    const total = await collection.estimatedDocumentCount({});

    // Set up limits and offsets used in pagination
    const totalPages = total > pageSize ? Math.ceil(total / pageSize) : 1;
    const skips = pageSize * (page - 1);

    // Find the paginated data
    const pagedData = await collection
        .find({})
        .skip(skips)
        .limit(pageSize)
        .toArray();

    // Return the paginated data with a metadata tag containing information about pagination
    return res.send({
        metadata: {
            total,
            totalPages,
            page,
            pageSize,
        },
        data: pagedData.map(reports.mapRow),
    });
});

// Provides demographic information about customers
router.get("/customers", async (req, res) => {
    // Cache the pointer to the database collection
    const collection = await req.context.db.collection("survey_data");

    // Fetch the reports for this resource URL
    const customersByAge = await reports.customerAge(collection);
    const customerIncome = await reports.customerIncome(collection);
    const customerMaritalStatus = await reports.customerMaritalStatus(
        collection
    );

    // Send the response
    res.send({
        data: {
            customersByAge,
            customerIncome,
            customerMaritalStatus,
        },
    });
});

// Breaks down sales statistics by geography
router.get("/geography", async (req, res) => {
    // Cache the pointer to the database collection
    const collection = await req.context.db.collection("survey_data");

    // Fetch the reports for this resource URL
    const salesByState = await reports.salesByState(collection);
    const averageRestaurantSpend = await reports.averageRestaurantSpendByState(
        collection
    );

    // Send the response
    res.send({
        data: {
            salesByState,
            averageRestaurantSpend,
        },
    });
});

// Shows sales data statistics
router.get("/sales", async (req, res) => {
    // Cache the pointer to the database collection
    const collection = await req.context.db.collection("survey_data");

    // Fetch the reports for this resource URL
    const totalSalesBySource = await reports.totalSalesBySource(collection);
    const averageSalesBySource = await reports.averageSalesBySource(collection);
    const averageSpendPerSourceByMaritalStatus =
        await reports.averageSpendPerSourceByMaritalStatus(collection);

    // Send the response
    res.send({
        data: {
            totalSalesBySource,
            averageSalesBySource,
            averageSpendPerSourceByMaritalStatus,
        },
    });
});

export default router;
