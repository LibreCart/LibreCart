import React, { Children, useEffect, useState } from "react";

import ApiPlatform from '../Utils/ApiPlatform';
import { Category } from "../Interfaces/Category";

function Nav() {

    const [categories, setCategories] = useState([]);

    const buildCategoryTree = (categories: Category[]) => {
        const categoryMap:any = {};

        categories.forEach((category) => {
            categoryMap[category.id] = { ...category, children: []}
        });

        const rootCategories: any = [];

        // Build the tree structure by linking parents and children
        categories.forEach((category) => {
            const { id, parentCategory } = category;
            if (parentCategory) {
                const parentId = parentCategory.split('/').pop(); // Extract the parent category ID
                if (categoryMap[parentId]) {
                    categoryMap[parentId].children.push(categoryMap[id]);
                }
            } else {
                rootCategories.push(categoryMap[id]); // If no parent, it's a root category
            }
        });
        
        return rootCategories;
    }

    const renderCategory = (category: Category) => (
        <li key={category.id}>
            <a href={"/" + category.urlKey}>
                {category.urlKey}
            </a>

            {category.children.length > 0 && (
                <ul className="pl-6 mt-2 border-l border-gray-200">
                    {category.children.map((child) => renderCategory(child))}
                </ul>
            )}
        </li>
    );

    useEffect(() => {
        ApiPlatform.get('categories').then((categories) => {
            setCategories(buildCategoryTree(categories));
        });
    });

    return(
        <div className="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
            <ul className="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                {categories.map((category) => renderCategory(category))}
            </ul>
        </div>
    );
}

export default Nav;