import { PermissionGroup } from './permission-group.model';

export interface Role {
    id: number;
    name_pl: string;
    name_en: string;
    name_ru: string;
    permissions: Array<PermissionGroup>;
    isSelected?: boolean;
    isClosed: boolean;
}