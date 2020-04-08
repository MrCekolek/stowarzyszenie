export class Conflink {
    name_pl: string;
    name_en: string;
    name_ru: string;
    link: string;
    content_pl: string;
    content_en: string;
    content_ru: string;
    status: string;
    conference_id: string;

    constructor(link: Object) {
        this.name_pl = link['name_pl'];
        this.name_en = link['name_en'];
        this.name_ru = link['name_ru'];
        this.link = link['link'];
        this.content_pl = link['content_pl'];
        this.content_en = link['content_en'];
        this.content_ru = link['content_ru'];
        this.status = link['status'];
        this.conference_id = link['conference_id'];
    }
}