
export function customerAge() {

}

export function customerIncome() {

}

export async function salesByState(collection) {
    const results = await collection.aggregate([
        {
            "$group": {
                _id: "$state",
                sales: { 
                    "$sum": {
                        "$add": ["$Restaurant", "$Webstore_Spend", "$THIRD_SPEND"]
                    } 
                }
            }
        },
        {
            "$sort": { "_id": 1 }
        }
    ]).toArray();

    return results.reduce((acc, result) => {
        acc[result._id] = result.sales;
        return acc;
    }, {});
}

export async function averageRestaurantSpendByState(collection) {
    const results = await collection.aggregate([
        {
            "$group": {
                _id: "$state",
                averageRestaurantSpend: { 
                    "$avg": "$Restaurant"
                }
            }
        },
        {
            "$project": { averageRestaurantSpend: { "$round": [ "$averageRestaurantSpend", 2 ] } }
        },
        {
            "$sort": { "_id": 1 }
        }
    ]).toArray();

    return results.map(result => {
        return {
            state: result._id,
            avg: result.averageRestaurantSpend
        };
    });
}

export function totalSalesBySource() {

}

export function averageSpendPerSourceByMaritalStatus() {
    
}

export function mapRow(row) {
    return {
        _id: row._id,
        first_name: row.first_name,
        last_name: row.last_name,
        city: row.city,
        county: row.count,
        state: row.state,
        zip: row.zip,
        restaurant: row.Restaurant,
        restaurant_visits: row.RES_VISITS,
        web_purchase: row.WEB_PURCH_YN,
        web_spend: row.Webstore_Spend,
        web_visits: row.WEB_VISITS,
        third_party_spend: row.THIRD_SPEND,
        third_party_visits: row.THIRD_VISITS,
        age: row.Age,
        married: row.Married_YN,
        income: row.Income,
    }
}