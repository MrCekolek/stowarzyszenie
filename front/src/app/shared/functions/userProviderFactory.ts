import { UserProviderService } from "../../core/services/user-provider.service";

export function userProviderFactory(provider: UserProviderService) {
    return () => provider.load();
}