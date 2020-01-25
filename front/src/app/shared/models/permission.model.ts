export class Permission {
    translation_key: string;

    constructor(permission: Object) {
        this.translation_key = permission['translation_key'];
    }
}
