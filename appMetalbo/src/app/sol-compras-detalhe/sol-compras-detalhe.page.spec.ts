import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { SolComprasDetalhePage } from './sol-compras-detalhe.page';

describe('SolComprasDetalhePage', () => {
  let component: SolComprasDetalhePage;
  let fixture: ComponentFixture<SolComprasDetalhePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SolComprasDetalhePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(SolComprasDetalhePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
