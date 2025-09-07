## Infra as Code (Optional)

### Path
- Docker Compose → Kubernetes (K8s)
- GitOps (ArgoCD/Flux) for deployment promotion

### Steps
- Define K8s manifests (Deployments, Services, Ingress)
- Externalize secrets via K8s Secrets/Sealed Secrets
- Add GH Actions job to build/push and update GitOps repo

