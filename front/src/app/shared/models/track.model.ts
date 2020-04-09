export class Track {
    id: string;
    name_pl: string;
    name_en: string;
    name_ru: string;
    colour: string;
    interest_id: string;
    conference_id: string;
    track_chairs: any;
    track_reviewers: any;

    constructor(track: Object) {
        this.id = track['id'];
        this.name_pl = track['name_pl'];
        this.name_en = track['name_en'];
        this.name_ru = track['name_ru'];
        this.colour = track['colour'];
        this.interest_id = track['interest_id'];
        this.conference_id = track['conference_id'];
        this.track_chairs = track['track_chairs'];
        this.track_reviewers = track['track_reviewers'];
    }
}
