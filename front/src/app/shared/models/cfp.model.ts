export class Cfp {
    id: any;
    file_name: string;
    file: string;
    content_pl: string;
    content_en: string;
    content_ru: string;
    conference_id: string;

    constructor(cfp: Object) {
        this.file_name = cfp['file_name'];
        this.file = cfp['file'];
        this.content_pl = cfp['content_pl'];
        this.content_en = cfp['content_en'];
        this.content_ru = cfp['content_ru'];
        this.conference_id = cfp['conference_id'];
    }
}
