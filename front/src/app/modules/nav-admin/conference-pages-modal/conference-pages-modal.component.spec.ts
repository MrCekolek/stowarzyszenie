import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConferencePagesModalComponent } from './conference-pages-modal.component';

describe('ConferencePagesModalComponent', () => {
  let component: ConferencePagesModalComponent;
  let fixture: ComponentFixture<ConferencePagesModalComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ConferencePagesModalComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConferencePagesModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
