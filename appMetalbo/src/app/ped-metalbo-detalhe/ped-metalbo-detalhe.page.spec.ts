import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { PedMetalboDetalhePage } from './ped-metalbo-detalhe.page';

describe('PedMetalboDetalhePage', () => {
  let component: PedMetalboDetalhePage;
  let fixture: ComponentFixture<PedMetalboDetalhePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PedMetalboDetalhePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(PedMetalboDetalhePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
