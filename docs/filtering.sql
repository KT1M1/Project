-- Select all the food ids which contains any of the allergens
SELECT contains_allergen.food_id
FROM contains_allergen
WHERE contains_allergen.allergen_id IN (3, 1)
GROUP BY contains_allergen.food_id;
-- END


-- Select all the foods which are not selected via the top filter
SELECT food.*
FROM food
WHERE food.id NOT IN (
    SELECT contains_allergen.food_id
    FROM contains_allergen
    WHERE contains_allergen.allergen_id IN (1)
    GROUP BY contains_allergen.food_id
);
-- END


-- Select all the food ids which contains all the selected categories
SELECT contains_category.food_id
FROM contains_category
WHERE contains_category.category_id IN (26, 4)
GROUP BY contains_category.food_id
HAVING COUNT(contains_category.category_id) = 2;
-- END


-- Select all the foods which contains all the selected categories
SELECT food.*
FROM food
WHERE food.id IN (
    SELECT contains_category.food_id
    FROM contains_category
    WHERE contains_category.category_id IN (26, 4)
    GROUP BY contains_category.food_id
    HAVING COUNT(contains_category.category_id) = 2
);
-- END


-- Select all the foods which not contains any of the allergens and contains all the categories
SELECT food.*
FROM food
WHERE food.id NOT IN (
    SELECT contains_allergen.food_id
    FROM contains_allergen
    WHERE contains_allergen.allergen_id IN (1)
    GROUP BY contains_allergen.food_id
) AND food.id IN (
    SELECT contains_category.food_id
    FROM contains_category
    WHERE contains_category.category_id IN (26)
    GROUP BY contains_category.food_id
    HAVING COUNT(contains_category.category_id) = 1
);
-- END