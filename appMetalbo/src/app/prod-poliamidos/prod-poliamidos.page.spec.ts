import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { ProdPoliamidosPage } from './prod-poliamidos.page';

describe('ProdPoliamidosPage', () => {
  let component: ProdPoliamidosPage;
  let fixture: ComponentFixture<ProdPoliamidosPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ProdPoliamidosPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(ProdPoliamidosPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
