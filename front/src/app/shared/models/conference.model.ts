export class Conference {
    conference_id: number;
    name_pl: string;
    name_en: string;
    name_ru: string;
    content_pl: Object;
    content_en: Object;
    content_ru: Object;
    status: string;

    constructor(conference: Object) {
        this.conference_id = conference['conference_id'];
        this.name_pl = conference['name_pl'];
        this.name_en = conference['name_en'];
        this.name_ru = conference['name_ru'];
        this.content_pl = conference['content_pl'];
        this.content_en = conference['content_en'];
        this.content_ru = conference['content_ru'];
        this.status = conference['status'];
    }
}