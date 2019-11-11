import { PermissionGroup } from './permission-group.model';

export interface Role {
    id: number;
    name: string;
    permissions: Array<PermissionGroup>;
}