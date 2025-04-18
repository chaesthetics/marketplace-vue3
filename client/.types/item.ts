export interface UploadItems {
    title: string | null;
    file: File | null;
}

export interface Item {
    id: number;
    title: string;
    description: string | null;
    price: string;
    status: string;
    location: string | null;
    created_by: number;
    category_id: number | null;
    created_at: string;
    updated_at: string;
    file_path: string;
    file_name: string;
    file_type: string;
}

export type ItemsResponse = {
    data: Item[];
}