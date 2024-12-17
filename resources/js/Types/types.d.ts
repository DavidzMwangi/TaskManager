 export interface User extends Model{
    name: string
    email: string
    email_verified_at: string | null
    two_factor_confirmed_at: string | null
}

export interface Task extends Model{
    title: string
    description: string | null
    status:  boolean
}

export interface ListResponse<T> {
    current_page: number
    data: T[]
    first_page_url: string
    from: number
    last_page: number
    last_page_url: string
    links: Link[]
    next_page_url: string | null
    path: string
    per_page: number
    prev_page_url: string | null
    to: number
    total: number
}

export interface Link{
    url: string | null
    label: string
    active: boolean
}
 interface Model{
    id: number
    created_at: string | Date,
    updated_at: string | Date | null,
}
