export class Event {
    name_pl: string;
    name_en: string;
    name_ru: string;
    date: string;
    colour: string;
    description_pl: string;
    description_en: string;
    description_ru: string;
    conference_id: string;

    constructor(event: Object) {
        this.name_pl = event['name_pl'];
        this.name_en = event['name_en'];
        this.name_ru = event['name_ru'];
        this.date = event['date'];
        this.colour = event['colour'];
        this.description_pl = event['description_pl'];
        this.description_en = event['description_en'];
        this.description_ru = event['description_ru'];
        this.conference_id = event['conference_id'];
    }
}