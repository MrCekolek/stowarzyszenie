import { UserProviderService } from "../services/user/user-provider.service";

export function userProviderFactory(provider: UserProviderService) {
    return () => provider.load();
}