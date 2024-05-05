export interface Category {
    id: any;
    createdAt: any;
    updatedAt: any;
    parentCategory: any;
    parentCategoryId: string;
    categoryTranslations: any;
    products: any;
    urlKey: string;
    children: Category[]
}