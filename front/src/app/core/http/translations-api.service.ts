import { Injectable } from '@angular/core';
import { ApiService } from './api.service';

@Injectable({
    providedIn: 'root'
})
export class TranslationsApiService {

    constructor(
        private apiService: ApiService
    ) { }

    getTranslations() {
        return this.apiService.post('translation');
    }

    addTranslation(translation) {
        return this.apiService.post('translation/create', translation);
    }

    updateTranslations(translation) {
        return this.apiService.post('translation/update', translation);
    }
}
