import { ContentTypes } from './content-types';

export class CardContent {
    id: number;
    shared_id: number;
    name_pl: string;
    name_en: string;
    name_ru: string;
    type: ContentTypes;
    tile_id: number;
    tile_shared_id: number;
    options?: Array<any>;

    constructor(content: Object) {
        this.id = content['id'];
        this.shared_id = content['shared_id'];
        this.name_pl = content['name_pl'];
        this.name_en = content['name_en'];
        this.name_ru = content['name_ru'];
        this.tile_id = content['tile_id'];
        this.tile_shared_id = content['tile_shared_id'];
        this.options = content['options'];
    }
}