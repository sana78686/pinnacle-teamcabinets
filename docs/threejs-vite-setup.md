# Three.js + Vite — setup guide

Two common setups: **vanilla Three.js + Vite** (simplest) and **React + Vite + React Three Fiber** (UI-heavy apps).

---

## 1. Vanilla Three.js + Vite (recommended to start)

### Create project

```bash
npm create vite@latest my-three-app -- --template vanilla
cd my-three-app
npm install three
npm run dev
```

### Minimal scene (`main.js`)

```javascript
import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';

const canvas = document.createElement('canvas');
document.body.appendChild(canvas);

const scene = new THREE.Scene();
scene.background = new THREE.Color(0x111111);

const camera = new THREE.PerspectiveCamera(
  75,
  window.innerWidth / window.innerHeight,
  0.1,
  1000
);
camera.position.z = 5;

const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

const geometry = new THREE.BoxGeometry(1, 1, 1);
const material = new THREE.MeshStandardMaterial({ color: 0x00ff88 });
const cube = new THREE.Mesh(geometry, material);
scene.add(cube);

scene.add(new THREE.AmbientLight(0xffffff, 0.4));
const dir = new THREE.DirectionalLight(0xffffff, 1);
dir.position.set(5, 5, 5);
scene.add(dir);

const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;

function onResize() {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(window.innerWidth, window.innerHeight);
}
window.addEventListener('resize', onResize);

function animate() {
  requestAnimationFrame(animate);
  cube.rotation.x += 0.01;
  cube.rotation.y += 0.01;
  controls.update();
  renderer.render(scene, camera);
}
animate();
```

### `index.html`

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Three.js + Vite</title>
    <style>
      * { margin: 0; box-sizing: border-box; }
      body { overflow: hidden; }
      canvas { display: block; }
    </style>
  </head>
  <body>
    <script type="module" src="/main.js"></script>
  </body>
</html>
```

### Optional `vite.config.js`

```javascript
import { defineConfig } from 'vite';

export default defineConfig({
  server: { port: 5173, open: true },
});
```

---

## 2. React + Vite + React Three Fiber

For React UI around the 3D canvas (forms, HUD, routing).

```bash
npm create vite@latest my-r3f-app -- --template react
cd my-r3f-app
npm install three @react-three/fiber @react-three/drei
npm run dev
```

**`src/App.jsx`**

```jsx
import { Canvas } from '@react-three/fiber';
import { OrbitControls, Box } from '@react-three/drei';

export default function App() {
  return (
    <div style={{ width: '100vw', height: '100vh' }}>
      <Canvas camera={{ position: [0, 0, 5], fov: 75 }}>
        <color attach="background" args={['#111']} />
        <ambientLight intensity={0.4} />
        <directionalLight position={[5, 5, 5]} intensity={1} />
        <Box args={[1, 1, 1]}>
          <meshStandardMaterial color="#00ff88" />
        </Box>
        <OrbitControls makeDefault />
      </Canvas>
    </div>
  );
}
```

**`src/index.css`**

```css
html, body, #root { width: 100%; height: 100%; margin: 0; }
```

---

## 3. TypeScript (vanilla)

```bash
npm create vite@latest my-three-app -- --template vanilla-ts
cd my-three-app
npm install three
npm install -D @types/three
```

Use the same scene code in `main.ts`; types come from `@types/three`.

---

## 4. Assets (models, textures)

Put files under **`public/`** so they are served at the root:

```
public/
  models/
    scene.gltf
  textures/
    wood.jpg
```

```javascript
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

new GLTFLoader().load('/models/scene.gltf', (gltf) => {
  scene.add(gltf.scene);
});
```

For imports from `src/` (bundled):

```javascript
import woodUrl from './assets/wood.jpg';
const tex = new THREE.TextureLoader().load(woodUrl);
```

---

## 5. Scripts & production

| Command | Purpose |
|---------|---------|
| `npm run dev` | Dev server + HMR |
| `npm run build` | Output to `dist/` |
| `npm run preview` | Serve `dist/` locally |

**GitHub Pages / subpath deploy** — set `base` in `vite.config.js`:

```javascript
export default defineConfig({
  base: '/your-repo-name/',
});
```

---

## 6. Useful add-ons

| Need | Package / path |
|------|----------------|
| Orbit / fly controls | `three/examples/jsm/controls/OrbitControls.js` |
| glTF | `GLTFLoader` or `@react-three/drei` `useGLTF` |
| Debug GUI | `lil-gui` |
| Post-processing | `postprocessing` or `@react-three/postprocessing` |
| Physics | `@react-three/rapier` |

---

## 7. Checklist

1. Vite project + `three` installed  
2. Full-viewport canvas + `resize` listener  
3. `requestAnimationFrame` render loop  
4. Models/textures in `public/` or imported from `src/assets/`  
5. `npm run dev` for fast iteration  

---

## Quick pick

- **Demos, shaders, no React** → vanilla Three.js + Vite (§1)  
- **Dashboard / forms / React app** → Vite + React + R3F (§2)  

To scaffold this inside the repo, say where to put it (e.g. `team-cabinets/frontend/three-demo`).
