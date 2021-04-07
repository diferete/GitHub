import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { FatMetalboDetalhePage } from './fat-metalbo-detalhe.page';

describe('FatMetalboDetalhePage', () => {
  let component: FatMetalboDetalhePage;
  let fixture: ComponentFixture<FatMetalboDetalhePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ FatMetalboDetalhePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(FatMetalboDetalhePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
