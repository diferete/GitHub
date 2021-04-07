import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { PedMetalboPage } from './ped-metalbo.page';

describe('PedMetalboPage', () => {
  let component: PedMetalboPage;
  let fixture: ComponentFixture<PedMetalboPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PedMetalboPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(PedMetalboPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
