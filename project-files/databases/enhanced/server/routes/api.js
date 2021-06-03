import { Router } from 'express';

const router = Router();

// Paginates all results
router.get('/', async (req, res) => {
    const alaskaData = await req.context.db.collection('survey_data').find({state: "AK"}).toArray();
    console.log(alaskaData);
    return res.send(alaskaData);
});

router.get('/customers', async (req, res) => {
    
});

router.get('/geography', async (req, res) => {
    
});

router.get('/sales', async (req, res) => {
    
});

router.get('/statistics', async (req, res) => {
    
});

export default router;
