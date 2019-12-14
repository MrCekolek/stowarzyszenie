export class PortfolioTab {
    id: number;
    name_en?: string;
    name_pl?: string;
    name_ru?: string;
    position: number;
    admin_visibility: boolean;
    user_visibility: boolean;
    portfolio_id: number;

    constructor(portfolioTab: Object) {
        this.id = portfolioTab['portfolioTab']['id'];
        this.name_en = portfolioTab['portfolioTab']['name_en'];
        this.name_pl = portfolioTab['portfolioTab']['name_pl'];
        this.name_ru = portfolioTab['portfolioTab']['name_ru'];
        this.position = portfolioTab['portfolioTab']['position'];
        this.admin_visibility = portfolioTab['portfolioTab']['admin_visibility'];
        this.user_visibility = portfolioTab['portfolioTab']['user_visibility'];
        this.portfolio_id = portfolioTab['portfolioTab']['portfolio_id'];
      }
}