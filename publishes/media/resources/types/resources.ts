export type File = {
    id?: number,
    display_name: string,
    group: string,
    disk: string,
    filepath: string,
    filename: string,
    mimetype: string,
    size: number,
}

export type FileCollection = {
    id?: number,
    title: string,
    key?: string,
}