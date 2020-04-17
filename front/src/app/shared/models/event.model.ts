export class Event {
    name_pl: string;
    name_en: string;
    name_ru: string;
    datetime: any;
    hour: string;
    end: any;
    end_hour: string;
    colour: string;
    description_pl: string;
    description_en: string;
    description_ru: string;
    conference_id: string;
    date_changed: boolean;
    date_changed_end: boolean;

    constructor(event: Object) {
        this.name_pl = event['name_pl'];
        this.name_en = event['name_en'];
        this.name_ru = event['name_ru'];
        this.datetime = event['datetime'];
        this.hour = event['hour'];
        this.end = event['end'];
        this.end_hour = event['end_hour'];
        this.colour = event['colour'];
        this.description_pl = event['description_pl'];
        this.description_en = event['description_en'];
        this.description_ru = event['description_ru'];
        this.conference_id = event['conference_id'];
        this.date_changed = false;
        this.date_changed_end = false;
    }
}
