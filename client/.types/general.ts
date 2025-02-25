export type Link = {
  label: string;
  icon: string;
  to: string;
  showChildren?: boolean;
  children?: Link[];
  external?: boolean;
  canView: boolean;
};

export type Pagination = {
  current_page: number;
  from: number;
  last_page: number;
  path: string;
  per_page: number;
  to: number;
  total: number;
};

export type ErrorData = {
  message: string;
};

export type ErrorResponseData = {
  data: ErrorData;
};

export type ErrorResponse = {
  data: ErrorData;
  status: number;
};

export type SearchFilter = {
  columnField: string;
  dbColumnField?: string;
  operatorValue: string;
  type: string;
  value: string;
};

export type Filter = {
  currentPage: number;
  perPage: number;
  filters: SearchFilter[];
};
