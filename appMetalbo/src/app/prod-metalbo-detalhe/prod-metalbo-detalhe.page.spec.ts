import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { ProdMetalboDetalhePage } from './prod-metalbo-detalhe.page';

describe('ProdMetalboDetalhePage', () => {
  let component: ProdMetalboDetalhePage;
  let fixture: ComponentFixture<ProdMetalboDetalhePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ProdMetalboDetalhePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(ProdMetalboDetalhePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
