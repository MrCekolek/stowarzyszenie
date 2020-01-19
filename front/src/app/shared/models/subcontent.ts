export class Subcontent {
    id: number;
    shared_id: number;
    value_pl: string;
    value_en: string;
    value_ru: string;
    selected: boolean;
    position: number;
    admin_visibility: boolean;
    user_visibility: boolean;
    tile_content_id: number;
    tile_content_shared_id: number;

    constructor(content: Object) {
        this.id = content['id'];
        this.shared_id = content['shared_id'];
        this.value_pl = content['value_pl'];
        this.value_en = content['value_en'];
        this.value_ru = content['value_ru'];
        this.selected = content['selected'];
        this.position = content['position'];
        this.admin_visibility = content['admin_visibility'];
        this.user_visibility = content['user_visibility'];
        this.tile_content_id = content['tile_content_id'];
        this.tile_content_shared_id = content['tile_content_shared_id'];
    }
}