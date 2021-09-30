import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
  {
    path: '',
    redirectTo: '/auth/login',
    pathMatch: 'full',
  },
  //Tela principal do sistema
  {
    path: 'principal',
    loadChildren: () => import('./principal/principal.module').then((m) => m.PrincipalPageModule),
  },
  {
    path: 'fat-metalbo',
    loadChildren: () => import('./fat-metalbo/fat-metalbo.module').then((m) => m.FatMetalboPageModule),
  },
  {
    path: 'fat-steel',
    loadChildren: () => import('./fat-steel/fat-steel.module').then((m) => m.FatSteelPageModule),
  },
  {
    path: 'fat-poliamidos',
    loadChildren: () => import('./fat-poliamidos/fat-poliamidos.module').then((m) => m.FatPoliamidosPageModule),
  },
  {
    path: 'ped-metalbo',
    loadChildren: () => import('./ped-metalbo/ped-metalbo.module').then((m) => m.PedMetalboPageModule),
  },
  {
    path: 'ped-poliamidos',
    loadChildren: () => import('./ped-poliamidos/ped-poliamidos.module').then((m) => m.PedPoliamidosPageModule),
  },
  {
    path: 'prod-metalbo',
    loadChildren: () => import('./prod-metalbo/prod-metalbo.module').then((m) => m.ProdMetalboPageModule),
  },
  {
    path: 'prod-steel',
    loadChildren: () => import('./prod-steel/prod-steel.module').then((m) => m.ProdSteelPageModule),
  },
  {
    path: 'prod-poliamidos',
    loadChildren: () => import('./prod-poliamidos/prod-poliamidos.module').then((m) => m.ProdPoliamidosPageModule),
  },
  {
    path: 'fat-metalbo-detalhe',
    loadChildren: () =>
      import('./fat-metalbo-detalhe/fat-metalbo-detalhe.module').then((m) => m.FatMetalboDetalhePageModule),
  },
  {
    path: 'fat-steel-detalhe',
    loadChildren: () => import('./fat-steel-detalhe/fat-steel-detalhe.module').then((m) => m.FatSteelDetalhePageModule),
  },
  {
    path: 'ped-metalbo-detalhe',
    loadChildren: () =>
      import('./ped-metalbo-detalhe/ped-metalbo-detalhe.module').then((m) => m.PedMetalboDetalhePageModule),
  },
  {
    path: 'prod-metalbo-detalhe',
    loadChildren: () =>
      import('./prod-metalbo-detalhe/prod-metalbo-detalhe.module').then((m) => m.ProdMetalboDetalhePageModule),
  },
  {
    path: 'prod-steel-detalhe',
    loadChildren: () =>
      import('./prod-steel-detalhe/prod-steel-detalhe.module').then((m) => m.ProdSteelDetalhePageModule),
  },
  {
    path: 'lista-fosfatizacao',
    loadChildren: () =>
      import('./lista-fosfatizacao/lista-fosfatizacao.module').then((m) => m.ListaFosfatizacaoPageModule),
  },
  {
    path: 'lista-fofatizacao-detalhe',
    loadChildren: () =>
      import('./lista-fofatizacao-detalhe/lista-fofatizacao-detalhe.module').then(
        (m) => m.ListaFofatizacaoDetalhePageModule
      ),
  },
  {
    path: 'walkthrough',
    loadChildren: () => import('./walkthrough/walkthrough.module').then((m) => m.WalkthroughPageModule),
  },
  {
    path: 'getting-started',
    loadChildren: () => import('./getting-started/getting-started.module').then((m) => m.GettingStartedPageModule),
  },
  {
    path: 'auth/login',
    loadChildren: () => import('./login/login.module').then((m) => m.LoginPageModule),
  },
  {
    path: 'auth/signup',
    loadChildren: () => import('./signup/signup.module').then((m) => m.SignupPageModule),
  },
  // tslint:disable-next-line:max-line-length
  {
    path: 'auth/forgot-password',
    loadChildren: () => import('./forgot-password/forgot-password.module').then((m) => m.ForgotPasswordPageModule),
  },
  {
    path: 'app',
    loadChildren: () => import('./tabs/tabs.module').then((m) => m.TabsPageModule),
  },
  {
    path: 'contact-card',
    loadChildren: () => import('./contact-card/contact-card.module').then((m) => m.ContactCardPageModule),
  },
  // tslint:disable-next-line:max-line-length
  {
    path: 'forms-and-validations',
    loadChildren: () =>
      import('./forms/validations/forms-validations.module').then((m) => m.FormsValidationsPageModule),
  },
  {
    path: 'forms-filters',
    loadChildren: () => import('./forms/filters/forms-filters.module').then((m) => m.FormsFiltersPageModule),
  },
  {
    path: 'page-not-found',
    loadChildren: () => import('./page-not-found/page-not-found.module').then((m) => m.PageNotFoundModule),
  },
  {
    path: 'showcase',
    loadChildren: () => import('./showcase/showcase.module').then((m) => m.ShowcasePageModule),
  },
  {
    path: 'ped-compra-metalbo',
    loadChildren: () => import('./ped-compras/ped-compra-metalbo.module').then((m) => m.PedCompraMetalboPageModule),
  },
  {
    path: 'ped-compras-detalhe',
    loadChildren: () =>
      import('./ped-compras-detalhe/ped-compras-detalhe.module').then((m) => m.PedComprasDetalhePageModule),
  },
  {
    path: 'sol-compras',
    loadChildren: () => import('./sol-compras/sol-compras.module').then((m) => m.SolComprasPageModule),
  },
  {
    path: 'sol-compras-detalhe',
    loadChildren: () =>
      import('./sol-compras-detalhe/sol-compras-detalhe.module').then((m) => m.SolComprasDetalhePageModule),
  },
  {
    path: 'sol-compras-itens',
    loadChildren: () => import('./sol-compras-itens/sol-compras-itens.module').then((m) => m.SolComprasItensPageModule),
  },
  {
    path: 'met-enderecamento',
    loadChildren: () =>
      import('./met-enderecamento/met-enderecamento.module').then((m) => m.MetEnderecamentoPageModule),
  },
  {
    path: 'met-enderecamento-detalhe',
    loadChildren: () =>
      import('./met-enderecamento-detalhe/met-enderecamento-detalhe.module').then(
        (m) => m.MetEnderecamentoDetalhePageModule
      ),
  },
  {
    path: 'met-enderecamento-novo',
    loadChildren: () =>
      import('./met-enderecamento-novo/met-enderecamento-novo.module').then((m) => m.MetEnderecamentoNovoPageModule),
  },
  {
    path: '**',
    redirectTo: 'page-not-found',
  },
];
@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
