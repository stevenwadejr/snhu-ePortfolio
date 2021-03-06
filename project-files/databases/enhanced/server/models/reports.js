export async function customerAge(collection) {
    const results = await collection
        .aggregate([
            {
                $bucket: {
                    groupBy: "$Age", // Field to group by
                    boundaries: [18, 28, 38, 48, 58, 68, 78, 88], // Boundaries for the buckets
                    default: "Other", // Bucket id for documents which do not fall into a bucket
                    output: {
                        // Output for each bucket
                        count: { $sum: 1 },
                    },
                },
            },
            {
                $addFields: {
                    lowerBound: "$_id",
                    upperBound: {
                        $arrayElemAt: [
                            [18, 28, 38, 48, 58, 68, 78, 88],
                            {
                                $add: [
                                    {
                                        $indexOfArray: [
                                            [18, 28, 38, 48, 58, 68, 78, 88],
                                            "$_id",
                                        ],
                                    },
                                    1,
                                ],
                            },
                        ],
                    },
                },
            },
        ])
        .toArray();

    return results;
}

export async function customerMaritalStatus(collection) {
    const results = await collection
        .aggregate([
            {
                $group: {
                    _id: "$Married_YN",
                    count: { $sum: 1 },
                },
            },
        ])
        .toArray();

    return results.reduce((acc, result) => {
        acc[result._id == "Y" ? "Married" : "Not Married"] = result.count;
        return acc;
    }, {});
}

export async function customerIncome(collection) {
    const results = await collection
        .aggregate([
            {
                $bucket: {
                    groupBy: "$Income", // Field to group by
                    boundaries: [20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120], // Boundaries for the buckets
                    default: "Other", // Bucket id for documents which do not fall into a bucket
                    output: {
                        // Output for each bucket
                        count: { $sum: 1 },
                    },
                },
            },
            {
                $addFields: {
                    lowerBound: "$_id",
                    upperBound: {
                        $arrayElemAt: [
                            [20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120],
                            {
                                $add: [
                                    {
                                        $indexOfArray: [
                                            [
                                                20, 30, 40, 50, 60, 70, 80, 90,
                                                100, 110, 120,
                                            ],
                                            "$_id",
                                        ],
                                    },
                                    1,
                                ],
                            },
                        ],
                    },
                },
            },
        ])
        .toArray();

    return results;
}

export async function salesByState(collection) {
    const results = await collection
        .aggregate([
            {
                $group: {
                    _id: "$state",
                    sales: {
                        $sum: {
                            $add: [
                                "$Restaurant",
                                "$Webstore_Spend",
                                "$THIRD_SPEND",
                            ],
                        },
                    },
                },
            },
            {
                $sort: { _id: 1 },
            },
        ])
        .toArray();

    return results.reduce((acc, result) => {
        acc[result._id] = result.sales;
        return acc;
    }, {});
}

export async function averageRestaurantSpendByState(collection) {
    const results = await collection
        .aggregate([
            {
                $group: {
                    _id: "$state",
                    averageRestaurantSpend: {
                        $avg: "$Restaurant",
                    },
                },
            },
            {
                $project: {
                    averageRestaurantSpend: {
                        $round: ["$averageRestaurantSpend", 2],
                    },
                },
            },
            {
                $sort: { _id: 1 },
            },
        ])
        .toArray();

    return results.map((result) => {
        return {
            state: result._id,
            avg: result.averageRestaurantSpend,
        };
    });
}

export async function totalSalesBySource(collection) {
    const results = await collection
        .aggregate([
            {
                $group: {
                    _id: null,
                    restaurant: {
                        $sum: {
                            $add: ["$Restaurant"],
                        },
                    },
                    web: {
                        $sum: {
                            $add: ["$Webstore_Spend"],
                        },
                    },
                    third_party: {
                        $sum: {
                            $add: ["$THIRD_SPEND"],
                        },
                    },
                },
            },
        ])
        .toArray();

    return (
        results.map((result) => {
            delete result._id;
            return result;
        })[0] || {}
    );
}

export async function averageSalesBySource(collection) {
    const results = await collection
        .aggregate([
            {
                $group: {
                    _id: null,
                    restaurant: {
                        $avg: {
                            $add: ["$Restaurant"],
                        },
                    },
                    web: {
                        $avg: {
                            $add: ["$Webstore_Spend"],
                        },
                    },
                    third_party: {
                        $avg: {
                            $add: ["$THIRD_SPEND"],
                        },
                    },
                },
            },
            {
                $project: {
                    restaurant: {
                        $round: ["$restaurant", 0],
                    },
                    web: {
                        $round: ["$web", 0],
                    },
                    third_party: {
                        $round: ["$third_party", 0],
                    },
                },
            },
        ])
        .toArray();

    return (
        results.map((result) => {
            delete result._id;
            return result;
        })[0] || {}
    );
}

export async function averageSpendPerSourceByMaritalStatus(collection) {
    const results = await collection
        .aggregate([
            {
                $group: {
                    _id: "$Married_YN",
                    restaurant: {
                        $avg: {
                            $add: ["$Restaurant"],
                        },
                    },
                    web: {
                        $avg: {
                            $add: ["$Webstore_Spend"],
                        },
                    },
                    third_party: {
                        $avg: {
                            $add: ["$THIRD_SPEND"],
                        },
                    },
                },
            },
            {
                $project: {
                    restaurant: {
                        $round: ["$restaurant", 0],
                    },
                    web: {
                        $round: ["$web", 0],
                    },
                    third_party: {
                        $round: ["$third_party", 0],
                    },
                },
            },
            {
                $sort: { _id: 1 },
            },
        ])
        .toArray();

    return results.reduce((acc, result) => {
        acc[result._id == "Y" ? "Married" : "Not Married"] = {
            restaurant: result.restaurant,
            web: result.web,
            third_party: result.third_party,
        };
        return acc;
    }, {});
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
    };
}
