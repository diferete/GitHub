import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { ModalItensComponent } from './modal-itens.component';

describe('ModalItensComponent', () => {
  let component: ModalItensComponent;
  let fixture: ComponentFixture<ModalItensComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalItensComponent ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(ModalItensComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
