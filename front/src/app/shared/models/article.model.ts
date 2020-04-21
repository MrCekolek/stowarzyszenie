export class ArticleModel {
    title_pl: string;
    title_en: string;
    title_ru: string;
    abstract_pl: string;
    abstract_en: string;
    abstract_ru: string;
    file_name: string;
    file: string;
    user_id: string;
    track_id: string;
    keywords_pl: string;
    keywords_en: string;
    keywords_ru: string;

    constructor(article: Object) {
        this.title_pl = article['title_pl'];
        this.title_en = article['title_en'];
        this.title_ru = article['title_ru'];
        this.abstract_pl = article['abstract_pl'];
        this.abstract_en = article['abstract_en'];
        this.abstract_ru = article['abstract_ru'];
        this.file_name = article['file_name'];
        this.file = article['file'];
        this.user_id = article['user_id'];
        this.track_id = article['track_id'];
        this.keywords_pl = article['keywords_pl'];
        this.keywords_en = article['keywords_en'];
        this.keywords_ru = article['keywords_ru'];
    }
}
