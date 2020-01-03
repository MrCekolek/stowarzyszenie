export class PortfolioCard {
    id: number;
    name_en?: string;
    name_pl?: string;
    name_ru?: string;
    position: number;
    admin_visibility: boolean;
    user_vsibility: boolean;
    portfolio_tab_id: number;

    constructor(portfolioCard: Object) {
        this.id = portfolioCard['id'];
        this.name_en = portfolioCard['name_en'];
        this.name_pl = portfolioCard['name_pl'];
        this.name_ru = portfolioCard['name_ru'];
        this.position = portfolioCard['position'];
        this.admin_visibility = portfolioCard['admin_visibility'];
        this.user_vsibility = portfolioCard['user_vsibility'];
        this.portfolio_tab_id = portfolioCard['portfolio_tab_id'];
    }
}