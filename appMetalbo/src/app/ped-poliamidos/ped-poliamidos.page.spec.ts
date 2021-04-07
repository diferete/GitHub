import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { PedPoliamidosPage } from './ped-poliamidos.page';

describe('PedPoliamidosPage', () => {
  let component: PedPoliamidosPage;
  let fixture: ComponentFixture<PedPoliamidosPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PedPoliamidosPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(PedPoliamidosPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
