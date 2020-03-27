import { Directive, Input, ElementRef, ComponentFactory, ComponentRef, TemplateRef, ViewContainerRef, ComponentFactoryResolver } from '@angular/core';
import { LoadingComponent } from '../components/loading/loading.component';

@Directive({
  selector: '[appLoading]'
})
export class LoadingDirective {

  loadingFactory : ComponentFactory<LoadingComponent>;
  loadingComponent : ComponentRef<LoadingComponent>;

  @Input() 
  set apploading(loading: boolean) {
    this.vcRef.clear();

    if (loading) {
      this.loadingComponent = this.vcRef.createComponent(this.loadingFactory);
    } else {
      this.vcRef.createEmbeddedView(this.templateRef);
    }    
  }

  constructor(
    private templateRef: TemplateRef<any>, 
    private vcRef: ViewContainerRef, 
    private componentFactoryResolver: ComponentFactoryResolver) {
    this.loadingFactory = this.componentFactoryResolver.resolveComponentFactory(LoadingComponent);
  }

}
