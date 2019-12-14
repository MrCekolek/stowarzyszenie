import { Component, OnInit } from '@angular/core';
import { PortfolioService } from 'src/app/core/services/portfolio.service';

@Component({
  selector: 'app-whole-portfolio',
  templateUrl: './whole-portfolio.component.html',
  styleUrls: ['./whole-portfolio.component.scss']
})
export class WholePortfolioComponent implements OnInit {

  constructor(
    private portfolioService: PortfolioService
  ) { }

  ngOnInit() {
    this.portfolioService.getAllTabs().subscribe(value => console.log(value));
  }

}
