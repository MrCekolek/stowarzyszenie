export class AlertModel {
    type: string;
    message: string;

    constructor(type, mess) {
        this.type = type;
        this.message = mess;
    }
}