export * from "./props";
export * from "./api";
export * from "./state";
export * from "./form";

export enum UserRole {
  Admin = "Admin",
  User = "User",
}

export enum Tokens {
  User = "user_token",
  Admin = "admin_token",
}

export type DateString = string;

export interface IUser {
  readonly id?: string;
  readonly name?: string;
  readonly email?: string;
  readonly isBlocked?: boolean;
  readonly created_at?: DateString;
  readonly profile?: string;
}

export interface IContact {
  readonly id?: string;
  readonly name: string;
  readonly phone: string;
  readonly email?: string;
  readonly tags?: string[];
  readonly created_at?: DateString;
  readonly updated_at?: DateString;
}

export interface IInstance {
  readonly id?: string;
  readonly name: string;
  readonly phone: string;
  readonly whatsapp_number: string;
  readonly token: string;
  readonly status: 'connected' | 'disconnected' | 'connecting';
  readonly platform: 'whatsapp' | 'telegram' | 'instagram';
  readonly created_at?: DateString;
  readonly updated_at?: DateString;
}

export interface IMessage {
  readonly id?: string;
  readonly content: string;
  readonly contact: string;
  readonly instance: string;
  readonly type: 'simple' | 'scheduled' | 'recurring';
  readonly status: 'pending' | 'sent' | 'failed' | 'scheduled';
  readonly scheduledAt?: DateString;
  readonly sentAt?: DateString;
  readonly created_at?: DateString;
  readonly updated_at?: DateString;
}

export interface IApiKey {
  readonly id: string;
  readonly name: string;
  readonly key: string;
  readonly status: 'active' | 'inactive';
  readonly created_at?: DateString;
  readonly updated_at?: DateString;
}
