export class Interest {
    id: number;
    name_pl?: string;
    name_en?: string;
    name_ru?: string;
    is_selected: boolean;
    deleteLoading: boolean;
    editing: boolean;
    editing_loading: boolean;

    constructor(interest: Object) {
        this.id = interest['id'];
        this.name_pl = interest['name_pl'];
        this.name_en = interest['name_en'];
        this.name_ru = interest['name_ru'];
        this.is_selected = interest['is_selected'];
        this.deleteLoading = false;
        this.editing = false;
        this.editing_loading = false;
    }
}