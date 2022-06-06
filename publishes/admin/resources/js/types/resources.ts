export type Resource<Model> = {data: Model};
export type CollectionResource<Model> = {data: Model[]};

// DateTime

export type DateTime = {
    readable_diff: string
}
export type DateTimeResource = Resource<DateTime>;

// State

export type State = {
    label: string,
    value: string,
}
export type StateResource = Resource<State>;
export type StatesCollectionResource = CollectionResource<State>;

// User
export interface User {
    id: number;
    name: string;
    email: string;
    is_admin: boolean;
    created_at: DateTime;
    update_at: DateTime;
}
export type UserResource = Resource<User>;
export type UserCollectionResource = CollectionResource<User>

// ..