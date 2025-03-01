type Organization = {
  id: number;
  name: string;
};

export type UserProfile = {
  id: number;
  name: string;
  email: string;
  email_verified_at?: string | null;
  password: string;
  remember_token?: string;
  created_at?: string;
  updated_at?: string;
  deleted_at?: string | null;
  role: string;
  permissions: string[];
};

export type LoginCredentials = {
  email: string;
  password: string;
};

export type RegisterCredentials = {
  name: string;
  email: string;
  password: string;
}

export type LoginResponse = {
  token: string;
  user: UserProfile;
  permissions: string[];
};

export type RegisterResponse = {
  message: string;
}

export type CurrentUserResponse = {
  user: UserProfile;
  permissions: string[];
};
