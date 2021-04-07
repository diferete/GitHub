import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { PedCompraMetalboPage } from './ped-compra-metalbo.page';

describe('PedCompraMetalboPage', () => {
  let component: PedCompraMetalboPage;
  let fixture: ComponentFixture<PedCompraMetalboPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PedCompraMetalboPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(PedCompraMetalboPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
