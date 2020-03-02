export class PortfolioCard {
    id: number;
    shared_id: number;
    name_en?: string;
    name_pl?: string;
    name_ru?: string;
    position: number;
    admin_visibility: number;
    user_visibility: number;
    portfolio_tab_id: number;
    portfolio_tab_shared_id: number;
    tile_contents: object;

    constructor(portfolioCard: Object) {
        this.id = portfolioCard['id'];
        this.shared_id = portfolioCard['shared_id'];
        this.name_en = portfolioCard['name_en'];
        this.name_pl = portfolioCard['name_pl'];
        this.name_ru = portfolioCard['name_ru'];
        this.position = portfolioCard['position'];
        this.admin_visibility = portfolioCard['admin_visibility'];
        this.user_visibility = portfolioCard['user_visibility'];
        this.portfolio_tab_id = portfolioCard['portfolio_tab_id'];
        this.portfolio_tab_shared_id =  portfolioCard['portfolio_tab_shared_id'];
        this.tile_contents = portfolioCard['tile_contents'];
    }
}
