import { Router } from 'express';
import * as reports from '../models/reports.js';

const router = Router();

// Paginates all results
router.get('/', async (req, res) => {
    const pageSize = parseInt(req.query.limit) || 100;
    const page = parseInt(req.query.page) || 1;

    const collection = await req.context.db.collection('survey_data');
    const total = await collection.estimatedDocumentCount({});
    const totalPages = total > pageSize ? Math.ceil(total / pageSize) : 1;
    const skips = pageSize * (page - 1);

    const pagedData = await collection.find({}).skip(skips).limit(pageSize).toArray();
    return res.send({
        metadata: {
            total,
            totalPages,
            page,
            pageSize
        },
        data: pagedData.map(reports.mapRow)
    });
});

router.get('/customers', async (req, res) => {
    
});

router.get('/geography', async (req, res) => {
    const collection = await req.context.db.collection('survey_data');
    const salesByState = await reports.salesByState(collection);
    const averageRestaurantSpend = await reports.averageRestaurantSpendByState(collection);

    res.send({
        data: {
            salesByState,
            averageRestaurantSpend
        }
    });
});

router.get('/sales', async (req, res) => {
    
});

router.get('/statistics', async (req, res) => {
    
});

export default router;
