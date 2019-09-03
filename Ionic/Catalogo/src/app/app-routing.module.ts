import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'home',
    pathMatch: 'full'
  },
  {
    path: 'home',
    loadChildren: () => import('./pages/home/home.module').then(m => m.HomePageModule)
  },
  {
    path: 'list',
    loadChildren: () => import('./pages/list/list.module').then(m => m.ListPageModule)
  },
  { path: 'list-produtos', loadChildren: './pages/list-produtos/list-produtos.module#ListProdutosPageModule' },
  { path: 'list-usuarios', loadChildren: './pages/list-usuarios/list-usuarios.module#ListUsuariosPageModule' },
  { path: 'cadastro-usuarios', loadChildren: './pages/cadastro-usuarios/cadastro-usuarios.module#CadastroUsuariosPageModule' },
  { path: 'cadastro-produtos', loadChildren: './cadastro-produtos/cadastro-produtos.module#CadastroProdutosPageModule' }
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule {}
