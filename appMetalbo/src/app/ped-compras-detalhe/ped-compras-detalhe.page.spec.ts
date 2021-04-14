import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { PedComprasDetalhePage } from './ped-compras-detalhe.page';

describe('PedComprasDetalhePage', () => {
  let component: PedComprasDetalhePage;
  let fixture: ComponentFixture<PedComprasDetalhePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PedComprasDetalhePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(PedComprasDetalhePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
